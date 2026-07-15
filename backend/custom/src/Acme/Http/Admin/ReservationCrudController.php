<?php

declare(strict_types=1);

namespace App\Custom\Acme\Http\Admin;

use App\Custom\Acme\Infrastructure\Doctrine\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Бронь стола')
            ->setEntityLabelInPlural('Брони столов (Acme)')
            ->setDefaultSort(['desiredAt' => 'DESC']);
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
        yield IntegerField::new('venueId', 'Точка');
        yield TextField::new('guestName', 'Гость');
        yield TextField::new('guestPhone', 'Телефон');
        yield IntegerField::new('peopleCount', 'Гостей');
        yield DateTimeField::new('desiredAt', 'Время визита');
        yield DateTimeField::new('createdAt', 'Создана')->hideOnIndex();
    }
}
