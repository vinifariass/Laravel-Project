<template>
  <div :class="estilo" role="alert">
    A mensagem de feedback
    {{  titulo  }}
    <hr>
    <p>{{  detalhes.mensagem  }}</p>

    <br>
    <ul v-if="detalhes.dados">
      <li v-for="e, key in detalhes.dados" :key="key"></li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ['tipo', 'titulo', 'detalhes'],
  computed: {

    estilo() {
      return 'alert alert-' + this.tipo
    }
  }
}
</script>
