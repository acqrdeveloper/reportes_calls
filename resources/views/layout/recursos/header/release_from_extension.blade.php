<template v-if="annexed != 0">
  <li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" @click="liberarAnexos" data-toggle="tooltip" data-placement="bottom" title="Extension Actual" style="color: white">
      <i class="fa fa-headphones"></i> Ext : @{{ annexed}}
    </a>
  </li>
</template>
