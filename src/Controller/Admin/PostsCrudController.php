<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use App\Entity\Posts;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Posts::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
                IdField::new('id')->hideOnForm(),
                AssociationField::new('category'),
                TextField::new('title'),
                TextField::new('prix'),
                TextEditorField::new('contenu'),
                ImageField::new('photo')->setUploadDir("public/assets/images")
                                        ->setBasePath("assets/images")
                                        ->setRequired(false),
            
        ];
    }
    
}
