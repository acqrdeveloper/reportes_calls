<aside class="main-sidebar">
  <section class="sidebar">
    @include('layout.recursos.left_menu.sidebar')

    <ul class="sidebar-menu" data-widget="tree" id="menuleft">
      <li class="header">Menu </li>

      <template v-if="getRole === 'admin' || getRole === 'supervisor'">
        <template v-if="getUsername === 'monitor' ">  @include('layout.recursos.left_menu.monitor') </template>
        <template v-else>  @include('layout.recursos.left_menu.supervision') </template>
      </template>

      <template v-if="getRole === 'user' ">  @include('layout.recursos.left_menu.user') </template>
      <template v-if="getRole === 'backoffice' ">  @include('layout.recursos.left_menu.backoffice') </template>
      <template v-if="getRole === 'calidad' ">  @include('layout.recursos.left_menu.calidad') </template>
      <template v-if="getRole === 'cliente' ">  @include('layout.recursos.left_menu.cliente') </template>
    </ul>
  </section>
</aside>
