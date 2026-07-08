<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\PosIntegration\PosConnection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * POS-подключения точек. Зашифрованный логин (apiLoginEncrypted) намеренно не
 * выводится — только статус, идентификаторы и результат последней синхронизации.
 */
class PosConnectionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PosConnection::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('POS-подключение')
            ->setEntityLabelInPlural('POS-подключения')
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
        yield TextField::new('posSystem', 'Система')->formatValue(
            static fn(mixed $value): mixed => $value instanceof \BackedEnum ? $value->value : $value,
        );
        yield TextField::new('status', 'Статус')->formatValue(
            static fn(mixed $value): mixed => $value instanceof \BackedEnum ? $value->value : $value,
        );
        yield TextField::new('organizationId', 'Organization ID')->hideOnIndex();
        yield TextField::new('externalMenuId', 'External Menu ID')->hideOnIndex();
        yield DateTimeField::new('lastSyncedAt', 'Синхронизация');
        yield TextField::new('lastError', 'Последняя ошибка')->hideOnIndex();
        yield DateTimeField::new('createdAt', 'Создано')->hideOnIndex();
    }
}
