<?php
declare( strict_types=1 );

// Count
class_alias( '\ArrayPress\Rules\EDD\Customer\Count\Service', '\Rules\EDD\CustomerServiceCount' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Count\Bundle', '\Rules\EDD\CustomerBundleCount' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Count\AllAccess', '\Rules\EDD\CustomerAllAccessCount' );

// Date
class_alias( '\ArrayPress\Rules\EDD\Customer\Date\Age', '\Rules\EDD\CustomerAge' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Date\Created', '\Rules\EDD\CustomerCreated' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Date\Modified', '\Rules\EDD\CustomerModified' );

// Field
class_alias( '\ArrayPress\Rules\EDD\Customer\Field\Email', '\Rules\EDD\CustomerEmail' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Field\Id', '\Rules\EDD\CustomerId' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Field\Name', '\Rules\EDD\CustomerName' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Field\OrderCount', '\Rules\EDD\CustomerOrderCount' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Field\PurchaseTotal', '\Rules\EDD\CustomerPurchaseTotal' );

// Product
class_alias( '\ArrayPress\Rules\EDD\Customer\Product\Product', '\Rules\EDD\CustomerProduct' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Product\Products', '\Rules\EDD\CustomerProducts' );

// Search
class_alias( '\ArrayPress\Rules\EDD\Customer\Search\Customer', '\Rules\EDD\CustomerSearch' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Search\Customers', '\Rules\EDD\CustomerSearches' );

// Taxonomy
class_alias( '\ArrayPress\Rules\EDD\Customer\Taxonomy\Category', '\Rules\EDD\CustomerCategory' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Taxonomy\Categories', '\Rules\EDD\CustomerCategories' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Taxonomy\Tag', '\Rules\EDD\CustomerTag' );
class_alias( '\ArrayPress\Rules\EDD\Customer\Taxonomy\Tags', '\Rules\EDD\CustomerTags' );