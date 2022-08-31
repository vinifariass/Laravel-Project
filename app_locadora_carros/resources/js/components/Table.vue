<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
      </tr>
    </thead>
    <tbody v-for="m in dados" :key="m.id">
      <tr>
        <th scope="row">{{ m.id }}</th>
        <td>{{ m.nome }}</td>
        <td>{{ m.imagem }}</td>
        <td><img :src="/storage/+m.imagem" alt=""></td>
      </tr>

    </tbody>
  </table>
</template>

<script>
export default {
  props: ['dados']
}
</script>
