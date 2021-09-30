<?php

return [

    'dashboards'        => [
        'description'   => 'The dashboard is the central place where you can control your campaign. Each campaign can fully customise the dashboard, adding widgets from a long list of available options. For large campaigns with multiple groups, :boosted-campaigns can create multiple dashboards tailored to each role.',
        'title'         => 'Campaign Dashboards',
    ],
    'gm'                => [
        'title' => 'Game Masters',
    ],
    'other_features'    => 'Other features',
    'worldbuilding'     => [
        'title' => 'Worldbuilders',
    ],
    'modular' => [
        'description'   => 'We\'ve focused our efforts on building about 20 different modules in Kanka that each focus on one aspect of playing a TTRPG or wordbuilding in general. In each campaign, you can create characters, locations, families, organisations, items, quests, journals, calendars, events, abilities and more. You don\'t need abilities? No problem, you can disable modules of your choice in each campaign, simplifying your setup to focus on what\'s important to you.',
    ],
    'free' => [
        'description' => 'Tired of having to pay for basic features like unlimited campaigns, limits on the number of users in a campaign, or being able to control who sees what? We are too, which is why all core features of Kanka are absolutely free. We have some :bonuses that unlock mostly visual changes rather than functionality.',
    ],
    'collaborative' => [
        'description' => 'We\'ve build Kanka to support worlds with multiple members and multiple campaigns. Add your friends to the campaign, assign them to one or several roles, and control what features and information they have access to. At any time you can also view the campaign as a member to make sure you haven\'t left content visible that they shouldn\'t have access to.',
    ],
    'updates' => [
        'title' => 'Frequent updates',
        'description'   => 'Kanka isn\'t just a :small-team of passionate worldbuilders. It\'s a huge community of dedicated users who help us shape and push frequent updates. We take pride in focusing on features that our community want and love. On average, we release two big updates every month to all users, with some months where we spoil our users with more. We go into details about these upcoming updates and feedback on our :discord.',
        'small-team' => 'team of two',
    ],
    'entity' => [
        'title' => 'Entities in Kanka',
        'description' => 'Kanka is built around a list of about 20 different entities. These are the pre-defined types of core objects in a campaign. These are characters, locations, families, items, quests, journals, calendars, timelines, and more. They all share some functionality but are unique in their own way and interact with other elements of your campaign. ',
    ],
    'sections' => [
        'worldbuilding' => 'Worldbuilding',
        'general' => 'General',
        'rpg' => 'RPGs',
        'boosted' => 'Boosted features',
    ],
    'inventory' => [
        'title' => 'Inventory',
        'description' => 'Every entity can have it\'s own inventory. This feature is used to manage a character\'s possessions, a shop\'s (location) sale inventory, a quest\'s reward for completing it, a family\'s fortune, or any other scenarios you can think of. The inventory feature interacts with the items of your campaign, but is flexible and can be used without creating every item in your campaign.',
    ],
    'abilities' => [
        'title' => 'Abilities',
        'description' => 'As with inventories, every entity can have abilities. Create abilities in your campaign, and attach them to your entities. These can be the powers of a character, the effects of a lair (location), a special ability granted from being part of a family, or a curse caused by eating a hag\'s cupcake. Abilities have charges to keep track of how often they were used, and can be combined with an entity\'s attributes.',
    ],
    'attributes' => [
        'title' => 'Attributes',
        'description' => 'Probably the most confusing and complex feature of entities are their attributes. These can be little bits of information like tracking a character\'s HP, a location\'s population, a religion (organisation)\'s number of shrines, etc. Attributes of an entity can reference each other to calculate values, for example a character\'s HP, where HP = Level * Constitution.',
        'secondary' => 'An entity\'s attributes can also be be styled to look like a TTRPG character sheet through our :marketplace.'
    ],
    'relations' => [
        'description' => 'Need to keep track that Svynna is the rival of Mykel, or that Washington is the birthplace of Kyle? Use our relations tool to set up and keep track of all the connections between the entities of your world. Need a relation to be kept secret from your players? Easy, just set the relation to private!',
        'secondary' => ':boosted-campaigns have access to a visual explorer for relations of an entity.'
    ],
    'timelines' => [
        'description' => 'Timelines allow you to visually see and plan out a country\'s history, a family\'s rise to power, a character\'s story arc, and other options. Timelines are split in eras, and each era contains elements of text that can be attached to other entities of your campaign.',
    ],
    'calendars' => [
        'description' => 'Create one or several calendars of your world, fully controlling the number of days in a year, the months, length of weeks, seasons, moons and their phases, and more. Attach events to your calendars linked to other entities, and for example automatically calculate a character\'s age based on the calendar.',
    ],
    'maps' => [
        'description' => 'Upload your beautiful maps to your Kanka campaign, and add layers and pins to them. Control who can see which pin, to avoid revealing the secret location of an infamous city to your players.',
    ],
    'journals' => [
        'title' => 'Journals',
        'description' => 'Plan your session or write a session recap in the eyes of a character using our journals module. These can be attached to calendars to keep track of both the real world date and in game date something happened.'
    ],
    'boosters' => [
        'title' => 'Campaign Boosters',
        'description' => 'Some features are only available to boosted campaigns. When a user subscribes to Kanka, they become a set number of boosts that they can attribute to one or several campaigns. These boosts can be moved around from one campaign to another, for example when a campaign ends. As long as a user stays a subscriber, they keep their boosts.',
        'link' => 'See all boosted features on our pricing page.',
    ],
    'marketplace' => [
        'title' => 'Marketplace',
        'description' => 'Boosted campaigns can install plugins from the :marketplace. These are themes, attribute templates or content packs created by the community for the community.',
    ],
    'theming' => [
        'title' => 'Theming',
        'description' => 'Boosted campaigns can force the theme users see when viewing it, but also write their own CSS to fully customise the campaign\'s look and feel.',
    ],
    'links' => [
        'title' => 'Links',
        'description' => 'Entities in a boosted campaign have a new type of asset that can be attach to it: links. These are displayed in the story mode of an entity and allow to quickly go for example to a character\'s DNDBeyond page.',
    ],
    'quests' => [
        'title' => 'Quests',
        'description' => 'Prepare and keep track of your game\'s quests, where it will take the players, who\'s involved, and what organisations are secretly pulling the strings. Once a quest is complete, flag it as such and move on to the next one.',
    ],
    'editor' => [
        'title' => 'Editor',
        'description' => 'You won\'t need to learn programing to create beautiful texts. Thanks to :summernote, you can create rich text for all your texts. Best of all, we\'ve added support for mentions to other entities by using the :at-code symbol.',
    ],
    'register' => 'Like what you see? Create a free account now',
    'discover-all' => 'Discover our amazing features',
];
