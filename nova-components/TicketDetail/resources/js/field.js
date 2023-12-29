import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-ticket-detail', IndexField)
  app.component('detail-ticket-detail', DetailField)
  app.component('form-ticket-detail', FormField)
})
