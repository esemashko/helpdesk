import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-color-badge', IndexField)
  app.component('detail-color-badge', DetailField)
  app.component('form-color-badge', FormField)
})
