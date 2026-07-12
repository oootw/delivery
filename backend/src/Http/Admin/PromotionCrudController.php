<?php

declare(strict_types=1);

namespace App\Http\Admin;

use App\Infrastructure\Doctrine\Domain\Promotion\Promotion;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PromotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Promotion::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Акция')
            ->setEntityLabelInPlural('Акции и промокоды')
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
        yield IntegerField::new('workspaceId', 'Воркспейс');
        yield IntegerField::new('venueId', 'Точка')->hideOnIndex();
        yield TextField::new('name', 'Название');
        yield TextField::new('type', 'Тип')->formatValue($this->enumValue());
        yield TextField::new('code', 'Промокод');
        yield TextField::new('rewardType', 'Тип награды')->formatValue($this->enumValue());
        yield IntegerField::new('rewardValue', 'Значение награды (б.п./коп)');
        yield TextField::new('target', 'Цель')->formatValue($this->enumValue());
        yield ArrayField::new('targetRefs', 'Цели (externalId)')->onlyOnDetail();
        yield ArrayField::new('conditions', 'Условия')->onlyOnDetail();
        yield IntegerField::new('priority', 'Приоритет')->hideOnIndex();
        yield BooleanField::new('stackable', 'Стекается')->renderAsSwitch(false);
        yield IntegerField::new('maxRedemptions', 'Лимит всего')->hideOnIndex();
        yield IntegerField::new('maxRedemptionsPerCustomer', 'Лимит на гостя')->hideOnIndex();
        yield IntegerField::new('redemptionsCount', 'Применений');
        yield BooleanField::new('isActive', 'Активна')->renderAsSwitch(false);
        yield DateTimeField::new('createdAt', 'Создана')->hideOnIndex();
    }

    private function enumValue(): callable
    {
        return static fn(mixed $value): mixed => $value instanceof \BackedEnum ? $value->value : $value;
    }
}
