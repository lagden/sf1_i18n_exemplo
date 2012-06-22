<?php
class CommonQuery extends Doctrine_Template
{    
    public function getByCultureTableProxy($culture = 'pt', Doctrine_Query $q = null)
    {
        if(null === $q) $q = $this->getTable()->createQuery('a');
        $alias = $q->getRootAlias();

        $q->leftJoin("{$alias}.Translation t")->andWhere("t.lang = ?", $culture);

        return $q;
    }

    public function getOneByRouteAndCultureTableProxy($route, $culture = 'pt', Doctrine_Query $q = null)
    {
        $q = $this->getByCultureTableProxy($culture, $q);
        $alias = $q->getRootAlias();
        
        $q->andWhere("{$alias}.slug_route = ?", $route);

        return $q;
    }
}
