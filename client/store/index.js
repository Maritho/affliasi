export const state = () => ({
  provincies: []
})

export const mutations = {
  add_provincies(state, data) {
    state.provincies = data;
  }
}
