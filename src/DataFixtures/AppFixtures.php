<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Epargne;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\Tontine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Groupement
        $groupement = new Groupement();
        $groupement->setNom('Avec Les Femmes');
        $manager->persist($groupement);

        // Admin
        $admin = new Admin();
        $admin->setNom('Diallo');
        $admin->setTel('770000000');
        $admin->setAdresse('Dakar');
        $admin->setLogin('admin');
        $admin->setPassword('passer123');
        $admin->setFonction('Présidente');
        $admin->setGroupement($groupement);
        $manager->persist($admin);

        // 5 membres
        for ($i = 1; $i <= 5; $i++) {
            $membre = new Membre();
            $membre->setNom('Membre ' . $i);
            $membre->setTel('77000000' . $i);
            $membre->setAdresse('Pikine');
            $membre->setLogin('membre' . $i);
            $membre->setPassword('passer123');
            $membre->setFonction('Membre');
            $membre->setGroupement($groupement);
            $manager->persist($membre);
        }

        // Tontine
        $tontine = new Tontine();
        $tontine->setNom('Tontine 2026');
        $tontine->setDateDebutAt(new \DateTime('2026-01-01'));
        $tontine->setDateFinAt(new \DateTime('2026-12-31'));
        $tontine->setMontant(10000);
        $tontine->setGroupement($groupement);
        $manager->persist($tontine);

        // Épargne
        $epargne = new Epargne();
        $epargne->setNom('Épargne Tabaski');
        $epargne->setDateDebutAt(new \DateTime('2026-02-01'));
        $epargne->setDateFinAt(new \DateTime('2026-06-30'));
        $epargne->setMontant(5000);
        $epargne->setGroupement($groupement);
        $manager->persist($epargne);

        $manager->flush();
    }
}