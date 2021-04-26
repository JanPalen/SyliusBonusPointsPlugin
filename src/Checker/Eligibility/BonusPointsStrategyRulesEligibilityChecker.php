<?php

declare(strict_types=1);

namespace BitBag\SyliusBonusPointsPlugin\Checker\Eligibility;

use BitBag\SyliusBonusPointsPlugin\Checker\Rule\BonusPointsStrategyRuleCheckerInterface;
use BitBag\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyInterface;
use BitBag\SyliusBonusPointsPlugin\Entity\BonusPointsStrategyRuleInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Registry\ServiceRegistryInterface;

final class BonusPointsStrategyRulesEligibilityChecker implements BonusPointsStrategyEligibilityCheckerInterface
{
    /** @var ServiceRegistryInterface */
    private $ruleRegistry;

    public function __construct(ServiceRegistryInterface $ruleRegistry)
    {
        $this->ruleRegistry = $ruleRegistry;
    }

    public function isEligible(ProductInterface $product, BonusPointsStrategyInterface $bonusPointsStrategy): bool
    {
        if (!$bonusPointsStrategy->hasRules()) {
            return false;
        }

        foreach ($bonusPointsStrategy->getRules() as $rule) {
            if (!$this->isEligibleToRule($product, $rule)) {
                return false;
            }
        }

        return true;
    }

    private function isEligibleToRule(ProductInterface $product, BonusPointsStrategyRuleInterface $rule): bool
    {
        /** @var BonusPointsStrategyRuleCheckerInterface $checker */
        $checker = $this->ruleRegistry->get($rule->getType());

        return $checker->isEligible($product, $rule->getConfiguration());
    }
}
