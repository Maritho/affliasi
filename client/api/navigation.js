const nav = {
  affliate: {
    class: 'layout-top-nav',
    nav: [],
  },
  admin: {
    class: 'sidebar-mini layout-fixed sidebar-open',
    nav: [
      {
        parent: 'AFFLIATE',
        nav: [
          {
            name: 'Campaign',
            icon: 'fa fa-circle-o',
            url: '/dashboard/affliate'
          },
          {
            name: 'Blogger',
            icon: 'fa fa-circle-o',
            url: '/dashboard/affliate'
          },
          {
            name: 'Penarikan',
            icon: 'fa fa-circle-o',
            url: '/dashboard/affliate'
          }
        ]
      }
    ]
  }
};

export default nav;
