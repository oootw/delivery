<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Loyalty\LoyaltyTier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LoyaltyTierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LoyaltyTier::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Уровень лояльности')
            ->setEntityLabelInPlural('Уровни лояльности')
            ->setDefaultSort(['workspaceId' => 'ASC', 'sortOrder' => 'ASC']);
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
        yield TextField::new('name', 'Название');
        yield MoneyField::new('thresholdKopecks', 'Порог трат')->setCurrency('RUB')->setStoredAsCents(true);
        yield IntegerField::new('earnRateBonusBasisPoints', 'Бонус к кэшбэку, б.п.');
        yield IntegerField::new('permanentDiscountBasisPoints', 'Постоянная скидка, б.п.');
        yield IntegerField::new('sortOrder', 'Порядок');
    }
}
