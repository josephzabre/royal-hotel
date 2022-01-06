<?php

namespace App\Controller\Admin;

use App\Entity\Slides;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class SlidesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slides::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            ImageField::new('photo')->setUploadDir("public/assets/images")
            ->setBasePath("assets/images")
            ->setRequired(false),
           
        ];
    }
    
}
