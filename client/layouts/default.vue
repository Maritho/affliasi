<template>
  <div class="wrapper">
    <template v-if="this.$store.state.auth.user.role.name == 'admin'">
      <nav class="main-header navbar navbar-expand bg-white navbar-white border-bottom">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" @click="pushMenu()" href="javascript:void(0)">
              <i class="fa fa-bars"></i>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link">
              <i class="fa fa-user-circle-o"></i> {{ this.$store.state.auth.user.name }}
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link" @click="logout()">
              <i class="fa fa-power-off"></i>
            </a>
          </li>
        </ul>
      </nav>
      <aside class="main-sidebar elevation-3 sidebar-light-primary" style="min-height: 669.043px;">
        <nuxt-link to="/dashboard/affliasi" class="brand-link bg-primary">
          <img
            src="https://moladin.com/images/moladin-logo-nav.png"
            alt="Moladin.com"
            width="132"
            class="img-fluid block-center"
          />
        </nuxt-link>

        <a class="mobile-close" @click="pushMenu()" href="javascript:void(0)">
          <i class="fa fa-close"></i>
        </a>

        <div class="sidebar">
          <nav class="mt-2">
            <ul
              class="nav nav-pills nav-sidebar flex-column"
              data-widget="treeview"
              role="menu"
              data-accordion="false">
              <template v-for="(item, index) in navigation[this.$store.state.auth.user.role.name].nav">
                <span class="sidebar-title mb-1" :key="index+'_name'">{{item.parent}}</span>
                <li v-for="(child, key) in item.nav" class="nav-item has-treeview" :key="key+'_child_'+index">
                  <nuxt-link :to="child.url" class="nav-link">
                    <i :class="child.icon" class="nav-icon"></i>
                    <p>{{child.name}}</p>
                  </nuxt-link>
                </li>
              </template>
            </ul>
          </nav>
        </div>
      </aside>
    </template>

    <template v-else>
      <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
          <nuxt-link to="/dashboard/affliasi" class="brand-link bg-primary">
            <img
              src="https://moladin.com/images/moladin-logo-nav.png"
              alt="Moladin.com"
              width="100"
              class="img-fluid block-center"
            />
          </nuxt-link>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <nuxt-link to="/dashboard/affliasi/summary" class="nav-link">
                <i class="fa fa-user-circle-o"></i> {{ this.$store.state.auth.user.name }}
              </nuxt-link>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0)" class="nav-link" @click="logout()">
                <i class="fa fa-power-off"></i>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </template>

    <nuxt/>

    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline">Version 1.0.0</div>
      <strong>
        Copyright &copy; 2014-2019
        <nuxt-link to="/">Moladin.com</nuxt-link>.
      </strong> All rights reserved.
    </footer>

  </div>
</template>

<script>

import nav from '../api/navigation';

export default {
  head() {
    return {
      bodyAttrs: {
        class: this.class
      }
    };
  },
  data() {
    return {
      class: nav[this.$store.state.auth.user.role.name].class,
      navigation: nav
    };
  },
  methods: {
    pushMenu() {
      if (this.class == "sidebar-mini layout-fixed sidebar-open") {
        this.class = "sidebar-mini layout-fixed sidebar-collapse";
      } else {
        this.class = "sidebar-mini layout-fixed sidebar-open";
      }
    },
    logout() {
      this.$auth.logout();
    }
  },
  mounted() {
    if(this.$store.state.auth.user.role.name == undefined || nav[this.$store.state.auth.user.role.name] == undefined) {
      this.logout();
    };
  }
};
</script>
