<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
                IdField::new('id')->hideOnForm(),
                TextField::new('title'),
                TextField::new('subTitle'),
                TextEditorField::new('contenu'),
                ImageField::new('photo')->setUploadDir("public/assets/images")
                                        ->setBasePath("assets/images")
                                        ->setRequired(false),
        ];
    }
    
}
