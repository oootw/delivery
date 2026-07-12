<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Loyalty\LoyaltyTransaction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LoyaltyTransactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LoyaltyTransaction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Движение баллов')
            ->setEntityLabelInPlural('Леджер баллов')
            ->setDefaultSort(['createdAt' => 'DESC']);
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
        yield IntegerField::new('accountId', 'Счёт');
        yield IntegerField::new('workspaceId', 'Воркспейс')->hideOnIndex();
        yield IntegerField::new('orderId', 'Заказ');
        yield TextField::new('type', 'Тип')->formatValue($this->enumValue());
        yield IntegerField::new('points', 'Баллы');
        yield IntegerField::new('balanceAfter', 'Баланс после');
        yield TextField::new('comment', 'Комментарий')->hideOnIndex();
        yield DateTimeField::new('createdAt', 'Дата');
    }

    private function enumValue(): callable
    {
        return static fn(mixed $value): mixed => $value instanceof \BackedEnum ? $value->value : $value;
    }
}
