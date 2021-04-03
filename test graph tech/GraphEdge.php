<?php

namespace craftitalk\GraphNodes;

use craftitalk\craftitalkRequest;
use craftitalk\Url\craftitalkUrlManipulator;
use craftitalk\Exceptions\craftitalkSDKException;

/**
 * Class GraphEdge
 *
 * @package craftitalk
 */
class GraphEdge extends Collection
{
    /**
     * @var craftitalkRequest The original request that generated this data.
     */
    protected $request;

    /**
     * @var array An array of Graph meta data like pagination, etc.
     */
    protected $metaData = [];

    /**
     * @var string|null The parent Graph edge endpoint that generated the list.
     */
    protected $parentEdgeEndpoint;

    /**
     * @var string|null The subclass of the child GraphNode's.
     */
    protected $subclassName;

    /**
     * Init this collection of GraphNode's.
     *
     * @param craftitalkRequest $request            The original request that generated this data.
     * @param array           $data               An array of GraphNode's.
     * @param array           $metaData           An array of Graph meta data like pagination, etc.
     * @param string|null     $parentEdgeEndpoint The parent Graph edge endpoint that generated the list.
     * @param string|null     $subclassName       The subclass of the child GraphNode's.
     */
    public function __construct(craftitalkRequest $request, array $data = [], array $metaData = [], $parentEdgeEndpoint = null, $subclassName = null)
    {
        $this->request = $request;
        $this->metaData = $metaData;
        $this->parentEdgeEndpoint = $parentEdgeEndpoint;
        $this->subclassName = $subclassName;

        parent::__construct($data);
    }

    /**
     * Gets the parent Graph edge endpoint that generated the list.
     *
     * @return string|null
     */
    public function getParentGraphEdge()
    {
        return $this->parentEdgeEndpoint;
    }

    /**
     * Gets the subclass name that the child GraphNode's are cast as.
     *
     * @return string|null
     */
    public function getSubClassName()
    {
        return $this->subclassName;
    }

    /**
     * Returns the raw meta data associated with this GraphEdge.
     *
     * @return array
     */
    public function getMetaData()
    {
        return $this->metaData;
    }

    /**
     * Returns the next cursor if it exists.
     *
     * @return string|null
     */
    public function getNextCursor()
    {
        return $this->getCursor('after');
    }

    /**
     * Returns the previous cursor if it exists.
     *
     * @return string|null
     */
    public function getPreviousCursor()
    {
        return $this->getCursor('before');
    }

    /**
     * Returns the cursor for a specific direction if it exists.
     *
     * @param string $direction The direction of the page: after|before
     *
     * @return string|null
     */
    public function getCursor($direction)
    {
        if (isset($this->metaData['paging']['cursors'][$direction])) {
            return $this->metaData['paging']['cursors'][$direction];
        }

        return null;
    }

    /**
     * Generates a pagination URL based on a cursor.
     *
     * @param string $direction The direction of the page: next|previous
     *
     * @return string|null
     *
     * @throws craftitalkSDKException
     */
    public function getPaginationUrl($direction)
    {
        $this->validateForPagination();

        // Do we have a paging URL?
        if (isset($this->metaData['paging'][$direction])) {
            // Graph returns the full URL with all the original params.
            // We just want the endpoint though.
            $pageUrl = $this->metaData['paging'][$direction];

            return craftitalkUrlManipulator::baseGraphUrlEndpoint($pageUrl);
        }

        // Do we have a cursor to work with?
        $cursorDirection = $direction === 'next' ? 'after' : 'before';
        $cursor = $this->getCursor($cursorDirection);
        if (!$cursor) {
            return null;
        }

        // If we don't know the ID of the parent node, this ain't gonna work.
        if (!$this->parentEdgeEndpoint) {
            return null;
        }

        // We have the parent node ID, paging cursor & original request.
        // These were the ingredients chosen to create the perfect little URL.
        $pageUrl = $this->parentEdgeEndpoint . '?' . $cursorDirection . '=' . urlencode($cursor);

        // Pull in the original params
        $originalUrl = $this->request->getUrl();
        $pageUrl = craftitalkUrlManipulator::mergeUrlParams($originalUrl, $pageUrl);

        return craftitalkUrlManipulator::forceSlashPrefix($pageUrl);
    }

    /**
     * Validates whether or not we can paginate on this request.
     *
     * @throws craftitalkSDKException
     */
    public function validateForPagination()
    {
        if ($this->request->getMethod() !== 'GET') {
            throw new craftitalkSDKException('You can only paginate on a GET request.', 720);
        }
    }

    /**
     * Gets the request object needed to make a next|previous page request.
     *
     * @param string $direction The direction of the page: next|previous
     *
     * @return craftitalkRequest|null
     *
     * @throws craftitalkSDKException
     */
    public function getPaginationRequest($direction)
    {
        $pageUrl = $this->getPaginationUrl($direction);
        if (!$pageUrl) {
            return null;
        }

        $newRequest = clone $this->request;
        $newRequest->setEndpoint($pageUrl);

        return $newRequest;
    }

    /**
     * Gets the request object needed to make a "next" page request.
     *
     * @return craftitalkRequest|null
     *
     * @throws craftitalkSDKException
     */
    public function getNextPageRequest()
    {
        return $this->getPaginationRequest('next');
    }

    /**
     * Gets the request object needed to make a "previous" page request.
     *
     * @return craftitalkRequest|null
     *
     * @throws craftitalkSDKException
     */
    public function getPreviousPageRequest()
    {
        return $this->getPaginationRequest('previous');
    }

    /**
     * The total number of results according to Graph if it exists.
     *
     * This will be returned if the summary=true modifier is present in the request.
     *
     * @return int|null
     */
    public function getTotalCount()
    {
        if (isset($this->metaData['summary']['total_count'])) {
            return $this->metaData['summary']['total_count'];
        }

        return null;
    }
}
