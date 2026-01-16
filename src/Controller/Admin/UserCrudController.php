<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id', 'ID')
            ->hideOnForm();

        $email = EmailField::new('email', 'Email');

        $nom = TextField::new('nom', 'Nom');

        $prenom = TextField::new('prenom', 'Prénom');

        // Champ non mappé, juste pour saisir le mot de passe en clair
        $plainPassword = TextField::new('plainPassword', 'Mot de passe')
            ->onlyOnForms()
            ->setRequired($pageName === 'new')
            ->setHelp('Laissez vide pour ne pas changer le mot de passe.')
            ->setFormTypeOption('mapped', false);

        $rolesIndex = ArrayField::new('roles', 'Rôles')
            ->onlyOnIndex();

        $rolesForm = ArrayField::new('roles', 'Rôles')
            ->onlyOnForms()
            ->setHelp('Ex : ROLE_USER, ROLE_ADMIN');

        $actif = BooleanField::new('actif', 'Actif');

        if ($pageName === 'index') {
            return [
                $id,
                $email,
                $nom,
                $prenom,
                $rolesIndex,
                $actif,
            ];
        }

        return [
            $id,
            $email,
            $nom,
            $prenom,
            $plainPassword,
            $rolesForm,
            $actif,
        ];
    }

    /**
     * Création
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $this->handlePassword($entityInstance);
        }

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    /**
     * Édition
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $this->handlePassword($entityInstance);
        }

        $entityManager->flush();
    }

    /**
     * Récupère le plainPassword du formulaire et le hash dans password
     */
    private function handlePassword(User $user): void
    {
        $request = $this->getContext()->getRequest();
        $formData = $request->request->all();

        // On cherche le champ "plainPassword" dans les données du formulaire,
        // quel que soit le nom du formulaire racine.
        $plainPassword = null;
        foreach ($formData as $fields) {
            if (is_array($fields) && array_key_exists('plainPassword', $fields)) {
                $plainPassword = $fields['plainPassword'];
                break;
            }
        }

        if (!empty($plainPassword)) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
        }
    }
}