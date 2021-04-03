<?php

namespace craftitalk\GraphNodes;

/**
 * Class GraphApplication
 *
 * @package craftitalk
 */

class GraphApplication extends GraphNode
{
    /**
     * Returns the ID for the application.
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getField('id');
    }
}
