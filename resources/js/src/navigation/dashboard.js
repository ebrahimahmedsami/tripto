// auth user
let user = localStorage.getItem('userData');
// gate
import Gate from '../Gate';
let gate = new Gate(JSON.parse(user));
export default [
  {
    title: 'Dashboards',
    route: 'apps-email',
    icon: 'HomeIcon',
  },
    {
        header: 'System Setup',
    },
    {
        title: 'Employee',
        icon: 'PackageIcon',
        allows: (gate.hasPermission('read users') || gate.hasPermission('write users')),
        children: [
            {
                title: 'Employee',
                route: 'employees',
                allows: gate.hasPermission('read users')
            },
            {
                title: 'Add_Employee',
                route: 'add-employee',
                allows: gate.hasPermission('write users')
            },
        ],
    },
  {
    header: 'Roles_Permissions',
  },
  {
    title: 'Roles_Section',
    icon: 'AlertCircleIcon',
    allows: (gate.hasPermission('read roles') || gate.hasPermission('write roles')),
    children: [
      {
        title: 'Roles',
        route: 'roles',
        allows:gate.hasPermission('read roles'),
      },
      {
        title: 'Assign_Roles',
        route: 'assign-role',
        allows:gate.hasPermission('write roles'),
      },
    ],
  },
  {
    header: 'System_Setup',
  },
  {
    title: 'Resorts',
    icon: 'CopyIcon',
    allows: (gate.hasPermission('read organizations') || gate.hasPermission('write organizations')),
    children: [
        {
            title: 'Resorts',
            route: 'organizations',
            allows:gate.hasPermission('read organizations')
        },
        {
            title: 'Add Resort',
            route: 'add-organization',
            allows:gate.hasPermission('write organizations')
        },
    ],
  },
  //   {
  //       title: 'Branches',
  //       icon: 'GitBranchIcon',
  //       allows: (gate.hasPermission('read branches') || gate.hasPermission('write branches')),
  //       children: [
  //           {
  //               title: 'Branch',
  //               route: 'branches',
  //               allows:gate.hasPermission('read branches'),
  //           },
  //           {
  //               title: 'Add_Branch',
  //               route: 'add-branch',
  //               allows:gate.hasPermission('write branches'),
  //           },
  //       ],

  //   },
  //   {
  //       title: 'Department',
  //       icon: 'PackageIcon',
  //       allows: (gate.hasPermission('read departments') || gate.hasPermission('write departments')),
  //       children: [
  //         {
  //           title: 'Department',
  //           route: 'departments',
  //           allows: gate.hasPermission('read departments')
  //         },
  //         {
  //           title: 'Add_Department',
  //           route: 'add-department',
  //           allows: gate.hasPermission('write departments')
  //         },
  //       ],
  //   },
  // {
  //   title: 'Services',
  //   icon: 'ServerIcon',
  //   allows: (gate.hasPermission('read services') || gate.hasPermission('write services')),
  //   children: [
  //     {
  //       title: 'Services',
  //       route: 'services',
  //       allows:gate.hasPermission('read services')
  //     },
  //     {
  //       title: 'Add_Services',
  //       route: 'add-service',
  //       allows:gate.hasPermission('write services')
  //     },
  //   ],
  // },

]
