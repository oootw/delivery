<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Loyalty\StampProgram;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class StampProgramCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StampProgram::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Штамп-карта')
            ->setEntityLabelInPlural('Штамп-карты')
            ->setDefaultSort(['workspaceId' => 'ASC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::EDIT, Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield IntegerField::new('workspaceId', 'Воркспейс');
        yield BooleanField::new('isEnabled', 'Включена')->renderAsSwitch(false);
        yield IntegerField::new('requiredCount', 'Штампов до награды');
        yield IntegerField::new('rewardPoints', 'Награда, баллов');
        yield DateTimeField::new('updatedAt', 'Обновлена')->hideOnIndex();
    }
}
