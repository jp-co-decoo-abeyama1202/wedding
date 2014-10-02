<?php
/**
 * @author admin-97
 */
class WorkGnaviFair extends Eloquent  {
    public function gnaviids()
    {
        return $this->has_many('WorkGnaviFairId');
    }
}
