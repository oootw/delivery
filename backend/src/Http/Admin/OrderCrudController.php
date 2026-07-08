<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Order\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Заказ')
            ->setEntityLabelInPlural('Заказы')
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
        yield IntegerField::new('venueId', 'Точка');
        yield IntegerField::new('customerId', 'Клиент');
        yield TextField::new('type', 'Тип')->formatValue($this->enumValue());
        yield TextField::new('status', 'Статус')->formatValue($this->enumValue());
        yield MoneyField::new('totalKopecks', 'Сумма')->setCurrency('RUB')->setStoredAsCents(true);
        yield IntegerField::new('estimatedWaitMinutes', 'ETA, мин')->hideOnIndex();
        yield TextField::new('contactName', 'Имя')->hideOnIndex();
        yield TextField::new('contactPhone', 'Телефон')->hideOnIndex();
        yield ArrayField::new('items', 'Позиции')->onlyOnDetail();
        yield ArrayField::new('history', 'История статусов')->onlyOnDetail();
        yield DateTimeField::new('createdAt', 'Создан');
    }

    private function enumValue(): callable
    {
        return static fn(mixed $value): mixed => $value instanceof \BackedEnum ? $value->value : $value;
    }
}
