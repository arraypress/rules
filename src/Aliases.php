<?php
declare( strict_types=1 );

namespace ArrayPress\Rules;

// User Date
class_alias( '\ArrayPress\Rules\User\Date\Age', '\ArrayPress\Rules\UserAge' );
class_alias( '\ArrayPress\Rules\User\Date\Registration', '\ArrayPress\Rules\UserDate' );

// User Field
class_alias( '\ArrayPress\Rules\User\Field\Description', '\ArrayPress\Rules\UserDescription' );
class_alias( '\ArrayPress\Rules\User\Field\Email', '\ArrayPress\Rules\UserEmail' );
class_alias( '\ArrayPress\Rules\User\Field\Emails', '\ArrayPress\Rules\UserEmails' );
class_alias( '\ArrayPress\Rules\User\Field\FirstName', '\ArrayPress\Rules\UserFirstName' );
class_alias( '\ArrayPress\Rules\User\Field\FullName', '\ArrayPress\Rules\UserFullName' );
class_alias( '\ArrayPress\Rules\User\Field\LastName', '\ArrayPress\Rules\UserLastName' );
class_alias( '\ArrayPress\Rules\User\Field\Nickname', '\ArrayPress\Rules\UserNickname' );
class_alias( '\ArrayPress\Rules\User\Field\Username', '\ArrayPress\Rules\UserUsername' );
class_alias( '\ArrayPress\Rules\User\Field\Website', '\ArrayPress\Rules\UserWebsite' );

// User Meta
class_alias( '\ArrayPress\Rules\User\Meta\Compare', '\ArrayPress\Rules\UserMetaCompare' );
class_alias( '\ArrayPress\Rules\User\Meta\CompareNumeric', '\ArrayPress\Rules\UserMetaCompareNumeric' );

// User Role
class_alias( '\ArrayPress\Rules\User\Role\Role', '\ArrayPress\Rules\UserRole' );
class_alias( '\ArrayPress\Rules\User\Role\Roles', '\ArrayPress\Rules\UserRoles' );

// User Search
class_alias( '\ArrayPress\Rules\User\Search\User', '\ArrayPress\Rules\User' );
class_alias( '\ArrayPress\Rules\User\Search\Users', '\ArrayPress\Rules\Users' );

// Post Dates
class_alias( '\ArrayPress\Rules\Post\Date\Age', '\ArrayPress\Rules\PostAge' );
class_alias( '\ArrayPress\Rules\Post\Date\Modified', '\ArrayPress\Rules\PostModified' );
class_alias( '\ArrayPress\Rules\Post\Date\Published', '\ArrayPress\Rules\PostPublished' );
class_alias( '\ArrayPress\Rules\Post\Date\Scheduled', '\ArrayPress\Rules\PostScheduled' );

// Post Field
class_alias( '\ArrayPress\Rules\Post\Field\Author', '\ArrayPress\Rules\PostAuthor' );
class_alias( '\ArrayPress\Rules\Post\Field\Authors', '\ArrayPress\Rules\PostAuthors' );
class_alias( '\ArrayPress\Rules\Post\Field\Content', '\ArrayPress\Rules\PostContent' );
class_alias( '\ArrayPress\Rules\Post\Field\ContentKeywords', '\ArrayPress\Rules\PostKeywords' );
class_alias( '\ArrayPress\Rules\Post\Field\Excerpt', '\ArrayPress\Rules\PostExcerpt' );
class_alias( '\ArrayPress\Rules\Post\Field\Permalink', '\ArrayPress\Rules\PostPermalink' );
class_alias( '\ArrayPress\Rules\Post\Field\Status', '\ArrayPress\Rules\PostStatus' );
class_alias( '\ArrayPress\Rules\Post\Field\Statuses', '\ArrayPress\Rules\PostStatuses' );
class_alias( '\ArrayPress\Rules\Post\Field\Template', '\ArrayPress\Rules\PostTemplate' );
class_alias( '\ArrayPress\Rules\Post\Field\Title', '\ArrayPress\Rules\PostTitle' );
class_alias( '\ArrayPress\Rules\Post\Field\TitleKeywords', '\ArrayPress\Rules\PostTitleKeywords' );
class_alias( '\ArrayPress\Rules\Post\Field\Type', '\ArrayPress\Rules\PostType' );
class_alias( '\ArrayPress\Rules\Post\Field\Types', '\ArrayPress\Rules\PostTypes' );

// Post Meta
class_alias( '\ArrayPress\Rules\Post\Meta\Compare', '\ArrayPress\Rules\PostMetaCompare' );
class_alias( '\ArrayPress\Rules\Post\Meta\CompareNumeric', '\ArrayPress\Rules\PostMetaCompareNumeric' );

// Post Search
class_alias( '\ArrayPress\Rules\Post\Search\Post', '\ArrayPress\Rules\Post' );
class_alias( '\ArrayPress\Rules\Post\Search\Posts', '\ArrayPress\Rules\Posts' );

// Post Taxonomy
class_alias( '\ArrayPress\Rules\Post\Taxonomy\Category', '\ArrayPress\Rules\PostCategory' );
class_alias( '\ArrayPress\Rules\Post\Taxonomy\Categories', '\ArrayPress\Rules\PostCategories' );
class_alias( '\ArrayPress\Rules\Post\Taxonomy\Tag', '\ArrayPress\Rules\PostTag' );
class_alias( '\ArrayPress\Rules\Post\Taxonomy\Tags', '\ArrayPress\Rules\PostTags' );

// Page Search
class_alias( '\ArrayPress\Rules\Page\Search\Page', '\ArrayPress\Rules\Page' );
class_alias( '\ArrayPress\Rules\Page\Search\Pages', '\ArrayPress\Rules\Pages' );