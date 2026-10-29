<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Amende;
use App\Entity\Campagne;
use App\Entity\Cotisation;
use App\Entity\Epargne;
use App\Entity\Exercice;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\ModePayement;
use App\Entity\Seance;
use App\Entity\Tontine;
use App\Enum\Periodicite;
use App\Enum\SituationCotisation;
use App\Enum\StatutExercice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1. Groupement
        $groupement = new Groupement();
        $groupement->setNom('Avec Les Femmes');
        $groupement->setAdresse('Pikine, Dakar');
        $groupement->setTel('+221 77 000 00 00');
        $manager->persist($groupement);

        // 2. Exercices (un clôturé, un en cours)
        $exercice2025 = new Exercice();
        $exercice2025->setDateDebutAt(new \DateTime('2025-01-01'));
        $exercice2025->setDateFinAt(new \DateTime('2025-12-31'));
        $exercice2025->setDateLimitePretAt(new \DateTime('2025-11-30'));
        $exercice2025->setDateRetributionAt(new \DateTime('2026-01-15'));
        $exercice2025->setStatut(StatutExercice::CLOTURE);
        $exercice2025->setGroupement($groupement);
        $manager->persist($exercice2025);

        $exercice2026 = new Exercice();
        $exercice2026->setDateDebutAt(new \DateTime('2026-01-01'));
        $exercice2026->setDateFinAt(new \DateTime('2026-12-31'));
        $exercice2026->setDateLimitePretAt(new \DateTime('2026-11-30'));
        $exercice2026->setDateRetributionAt(new \DateTime('2027-01-15'));
        $exercice2026->setStatut(StatutExercice::EN_COURS);
        $exercice2026->setGroupement($groupement);
        $manager->persist($exercice2026);

        // 3. Admin
        $admin = new Admin();
        $admin->setNom('Diallo');
        $admin->setTel(770000000);
        $admin->setAdresse('Dakar');
        $admin->setLogin('admin');
        $admin->setPassword('passer123');
        $admin->setFonction('Présidente');
        $admin->setGroupement($groupement);
        $manager->persist($admin);

        // 4. Cinq membres
        $membres = [];
        for ($i = 1; $i <= 5; $i++) {
            $membre = new Membre();
            $membre->setNom('Membre ' . $i);
            $membre->setTel(770000000 + $i);
            $membre->setAdresse('Pikine');
            $membre->setLogin('membre' . $i);
            $membre->setPassword('passer123');
            $membre->setFonction('Membre');
            $membre->setGroupement($groupement);
            $manager->persist($membre);
            $membres[] = $membre;
        }

        // 5. Campagnes
        $tontine = new Tontine();
        $this->remplirCampagne($tontine, 'Tontine 2026', '2026-01-01', '2026-12-31', 10000, Periodicite::MENSUELLE, $groupement);
        $manager->persist($tontine);

        $epargne = new Epargne();
        $this->remplirCampagne($epargne, 'Épargne calebasse', '2026-02-01', '2026-06-30', 5000, Periodicite::HEBDOMADAIRE, $groupement);
        $manager->persist($epargne);

        // 6. Participations : chaque membre participe aux deux campagnes
        foreach ([$tontine, $epargne] as $campagne) {
            foreach ($membres as $index => $membre) {
                $participation = new ModePayement();
                $participation->setCampagne($campagne);
                $participation->setRole($membre);
                // Le dernier membre choisit un montant libre sur l'épargne
                $libre = ($campagne === $epargne && $index === 4);
                $participation->setIsLibre($libre);
                $participation->setMontantChoisi($libre ? 7500 : $campagne->getMontant());
                $manager->persist($participation);
            }
        }

        // 7. Séances, cotisations et amendes
        $this->creerSeances($manager, $tontine, $membres, ['2026-01-31', '2026-02-28']);
        $this->creerSeances($manager, $epargne, $membres, ['2026-02-07', '2026-02-14', '2026-02-21']);

        $manager->flush();
    }

    private function remplirCampagne(
        Campagne $campagne,
        string $nom,
        string $debut,
        string $fin,
        int $montant,
        Periodicite $periodicite,
        Groupement $groupement
    ): void {
        $campagne->setNom($nom);
        $campagne->setDateDebutAt(new \DateTime($debut));
        $campagne->setDateFinAt(new \DateTime($fin));
        $campagne->setMontant($montant);
        $campagne->setPeriodicite($periodicite);
        $campagne->setJourRencontre(6); // samedi
        $campagne->setContributionCaissePresent(500);
        $campagne->setContributionCaisseAbsent(300);
        $campagne->setAmendeJournaliere(350);
        $campagne->setGroupement($groupement);
    }

    private function creerSeances(ObjectManager $manager, Campagne $campagne, array $membres, array $dates): void
    {
        foreach ($dates as $numero => $date) {
            $seance = new Seance();
            $seance->setDateSeanceAt(new \DateTime($date));
            $seance->setCampagne($campagne);
            $manager->persist($seance);

            foreach ($membres as $index => $membre) {
                // Membre absent qui n'a pas payé : amende de 3 jours (première séance seulement)
                if ($index === 4 && $numero === 0) {
                    $amende = new Amende();
                    $amende->setSeance($seance);
                    $amende->setMembre($membre);
                    $amende->setNombreJours(3);
                    $amende->setMontantParJour($campagne->getAmendeJournaliere());
                    $amende->setIsPayee(false);
                    $manager->persist($amende);
                    continue;
                }

                $cotisation = new Cotisation();
                $cotisation->setSeance($seance);
                $cotisation->setMembre($membre);
                $cotisation->setMontantEpargne($campagne->getMontant());

                if ($index === 3) {
                    // Absent mais l'argent a été envoyé par un autre membre
                    $cotisation->setSituation(SituationCotisation::ABSENT_REPRESENTE);
                    $cotisation->setContributionCaisse($campagne->getContributionCaisseAbsent());
                } else {
                    $cotisation->setSituation(SituationCotisation::PRESENT);
                    $cotisation->setContributionCaisse($campagne->getContributionCaissePresent());
                }
                $manager->persist($cotisation);
            }
        }
    }
}