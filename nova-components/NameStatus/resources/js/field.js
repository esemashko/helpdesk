import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-name-status', IndexField)
  app.component('detail-name-status', DetailField)
  app.component('form-name-status', FormField)
})
