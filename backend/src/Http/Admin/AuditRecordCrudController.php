<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Audit\AuditRecord;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * История изменений (аудит). Только на чтение — записи создаёт AuditSubscriber.
 */
class AuditRecordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AuditRecord::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Запись аудита')
            ->setEntityLabelInPlural('История изменений')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setPaginatorPageSize(50);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::EDIT, Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnIndex();
        yield DateTimeField::new('createdAt', 'Когда');
        yield TextField::new('actorLabel', 'Кто');
        yield TextField::new('action', 'Действие');
        yield TextField::new('entityType', 'Сущность');
        yield IntegerField::new('entityId', 'ID сущности');
        yield ArrayField::new('changes', 'Изменения')->onlyOnDetail();
    }
}
