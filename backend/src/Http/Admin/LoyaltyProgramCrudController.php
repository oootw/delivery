<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Loyalty\LoyaltyProgram;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class LoyaltyProgramCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LoyaltyProgram::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Программа лояльности')
            ->setEntityLabelInPlural('Программы лояльности')
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
        yield IntegerField::new('earnRateBasisPoints', 'Кэшбэк, б.п.');
        yield MoneyField::new('pointValueKopecks', 'Цена балла')->setCurrency('RUB')->setStoredAsCents(true);
        yield IntegerField::new('redeemMaxPercentBasisPoints', 'Лимит оплаты баллами, б.п.');
        yield IntegerField::new('pointsLifetimeDays', 'Срок жизни баллов, дней')->hideOnIndex();
        yield DateTimeField::new('updatedAt', 'Обновлена')->hideOnIndex();
    }
}
