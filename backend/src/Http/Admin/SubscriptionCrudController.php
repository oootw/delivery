<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Subscription\Subscription;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubscriptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Subscription::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Подписка')
            ->setEntityLabelInPlural('Подписки')
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
        yield IntegerField::new('userId', 'Пользователь');
        yield TextField::new('tarifCode', 'Тариф')->formatValue($this->enumValue());
        yield TextField::new('status', 'Статус')->formatValue($this->enumValue());
        yield TextField::new('invoiceId', 'Invoice')->hideOnIndex();
        yield TextField::new('externalId', 'CloudPayments ID')->hideOnIndex();
        yield DateTimeField::new('currentPeriodEnd', 'Оплачено до');
        yield DateTimeField::new('createdAt', 'Создана');
    }

    private function enumValue(): callable
    {
        return static fn(mixed $value): mixed => $value instanceof \BackedEnum ? $value->value : $value;
    }
}
