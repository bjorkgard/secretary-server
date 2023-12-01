export default {
  methods: {
    __(key, replace = {}) {
      let translation = this.$page.props.language[key]
        ? this.$page.props.language[key]
        : key
      Object.keys(replace).forEach((key) => {
        translation = translation.replace(`:${key}`, replace[key])
      })
      return translation
    },
  },
}
