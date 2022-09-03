<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col" v-for="t, key in titulos" :key="key" class="text-uppercase">{{ t.titulo }}</th>

      </tr>
    </thead>
    <tbody>
      <tr v-for="obj in dados" :key="obj.id">
        <td v-if="titulos.includes(chave)" v-for="valor, chave in obj " :key="chave">
          {{ chave }} - {{ valor }}
          <span v-if="chave == 'imagem'">
            <img :src="/storage/ + valor" alt="" width="30" height="30">
          </span>
          <span v-else>
            {{ valor }}
          </span>
        </td>
        <!-- <th scope="row">{{ m.id }}</th> -->
        <!-- <td>{{ m.nome }}</td>
        <td>{{ m.imagem }}</td>
        <td><img width="30" height="30" :src="/storage/ + m.imagem" alt="">
        </td> -->
      </tr>

    </tbody>
  </table>
</template>

<script>
export default {
  props: ['dados']
}
</script>
