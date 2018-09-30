module.exports = [
    {
        type: 'item',
        isHeader: true,
        name: 'SECTIONS'
    },
    {
        type: 'item',
        icon: 'fa fa-dashboard',
        name: 'Dashboard',
        router: {
            name: 'home'
        }
    },
    {
        type: 'tree',
        icon: 'fa fa-users',
        name: 'Users',
        items: [
            {
                type: 'item',
                icon: 'fa fa-th',
                name: 'Overview',
                router: {
                    name: 'users'
                }
            },
            {
                type: 'item',
                icon: 'fa fa-list',
                name: 'List Users',
                router: {
                    name: 'listUsers'
                }
            },
            {
                type: 'item',
                icon: 'fa fa-plus',
                name: 'Add User',
                router: {
                    name: 'createUser'
                }
            }
        ]
    },
    {
        type: 'tree',
        icon: 'fa fa-snowflake-o',
        name: 'Groups',
        items: [
            {
                type: 'item',
                icon: 'fa fa-th',
                name: 'Overview',
                router: {
                    name: 'groups'
                }
            },
            {
                type: 'item',
                icon: 'fa fa-list',
                name: 'List Groups',
                router: {
                    name: 'listGroups'
                }
            },
            {
                type: 'item',
                icon: 'fa fa-plus',
                name: 'Add Group',
                router: {
                    name: 'createGroup'
                }
            }
        ]
    },
    {
        type: 'tree',
        icon: 'fa fa-desktop',
        name: 'Clients',
        items: [
            {
                type: 'item',
                icon: 'fa fa-th',
                name: 'Overview',
                router: {
                    name: 'clients'
                }
            },
            {
                type: 'item',
                icon: 'fa fa-list',
                name: 'List Clients',
                router: {
                    name: 'listClients'
                }
            },
            {
                type: 'item',
                icon: 'fa fa-plus',
                name: 'Add Client',
                router: {
                    name: 'createClient'
                }
            }
        ]
    },
    {
        type: 'tree',
        icon: 'fa fa-line-chart',
        name: 'Statistics',
        items: [
            {
                type: 'item',
                icon: 'fa fa-th',
                name: 'Overview',
                router: {
                    name: 'statistics'
                }
            },
            {
                type: 'item',
                icon: 'fa fa-list',
                name: 'List Statistics',
                router: {
                    name: 'listStatistics'
                }
            },
            {
                type: 'item',
                icon: 'fa fa-plus',
                name: 'Add Statistics',
                router: {
                    name: 'createStatistics'
                }
            }
        ]
    }
];
