<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col" v-for="t, key in titulos" :key="key" class="text-uppercase">{{ t.titulo }}</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td v-for="obj, chave in dadosFiltrados" :key="chave"></td>
        <td v-for="valor, chaveValor in obj" :key="chaveValor">
          <span v-if="titulos[chaveValor].tipo == 'texto'">{{valor}}</span>
          <span v-if="titulos[chaveValor].tipo == 'data'">
              {{ '...'+valor}}
          </span>
          <span v-if="titulos[chaveValor].tipo == 'imagem'">
              <img :src="'/storage/'+valor" width="30" height="30">
          </span>
        </td>
      </tr>


    </tbody>
  </table>
</template>

<script>
export default {
  props: ['dados'],
  computed: {
    dadosFiltrados() {
      let campos = Object.keys(this.titulos)
      let dadosFiltrados = []

      this.dados.map((item, chave) => {
        let itemFiltrado = {}
        // console.log(chave, item)
        campos.forEach(campo => {

          itemFiltrado[campo] = item[campo] //sintaxe de array apara atribuir valores a objetos

        })
        dadosFiltrados.push(itemFiltrado)
      })
      return dadosFiltrados
    }
  }
}
</script>
