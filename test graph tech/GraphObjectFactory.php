<?php

namespace craftitalk\GraphNodes;

/**
 * Class GraphObjectFactory
 *
 * @package craftitalk
 *
 * @deprecated 5.0.0 GraphObjectFactory has been renamed to GraphNodeFactory
 * @todo v6: Remove this class
 */
class GraphObjectFactory extends GraphNodeFactory
{
    /**
     * @const string The base graph object class.
     */
    const BASE_GRAPH_NODE_CLASS = '\craftitalk\GraphNodes\GraphObject';

    /**
     * @const string The base graph edge class.
     */
    const BASE_GRAPH_EDGE_CLASS = '\craftitalk\GraphNodes\GraphList';

    /**
     * Tries to convert a craftitalkResponse entity into a GraphNode.
     *
     * @param string|null $subclassName The GraphNode sub class to cast to.
     *
     * @return GraphNode
     *
     * @deprecated 5.0.0 GraphObjectFactory has been renamed to GraphNodeFactory
     */
    public function makeGraphObject($subclassName = null)
    {
        return $this->makeGraphNode($subclassName);
    }

    /**
     * Convenience method for creating a GraphEvent collection.
     *
     * @return GraphEvent
     *
     * @throws craftitalkSDKException
     */
    public function makeGraphEvent()
    {
        return $this->makeGraphObject(static::BASE_GRAPH_OBJECT_PREFIX . 'GraphEvent');
    }

    /**
     * Tries to convert a craftitalkResponse entity into a GraphEdge.
     *
     * @param string|null $subclassName The GraphNode sub class to cast the list items to.
     * @param boolean     $auto_prefix  Toggle to auto-prefix the subclass name.
     *
     * @return GraphEdge
     *
     * @deprecated 5.0.0 GraphObjectFactory has been renamed to GraphNodeFactory
     */
    public function makeGraphList($subclassName = null, $auto_prefix = true)
    {
        return $this->makeGraphEdge($subclassName, $auto_prefix);
    }
}
