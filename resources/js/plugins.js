import {parseISO, format} from 'date-fns'
import mitt from 'mitt'

let LaravelError = {
    install: (app, options) => {
        // inject a globally available $translate() method
        app.config.globalProperties.$laravelError = (e, message) => {
            console.log(app)
            let response = e.response;
            if (response && response.status === 422 && response.data.errors) {
                let erro = Object.keys(response.data.errors)[0];
                app.config.globalProperties.$toast.open({
                    message: response.data.errors[erro][0],
                    type: 'error'
                });
            }else if (response && response.status === 401 && response.data.message) {
                app.config.globalProperties.$toast.open({
                    message: response.data.message,
                    type: 'error'
                });
            }else if (response && response.data.message) {
                app.config.globalProperties.$toast.open({
                    message: response.data.message,
                    type: 'error'
                });
            } else {
                app.config.globalProperties.$toast.open({
                    message: message,
                    type: 'error'
                });
            }
        }
    }
}

let filters = {
    install: (app, options) => {
        app.config.globalProperties.$filters = {

            data(value) {
                if (value === '0000-00-00 00:00:00') return ''
                return value ? format(parseISO(value), "dd/MM/yyyy") : '';
            },
            dataHora(value) {
                if (value === '0000-00-00 00:00:00') return ''
                return value ? format(parseISO(value), "dd/MM/yyyy HH:MM:ss") : '';
            },
            dinheiro(valor) {
                return (new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(valor));
            },
        }
    }
}

let EventBus = {
    install: (app, options) => {
        const emitter = mitt();
        app.config.globalProperties.$eventBus = {
            $on: (...args) => emitter.on(...args),
            $once: (...args) => emitter.once(...args),
            $off: (...args) => emitter.off(...args),
            $emit: (...args) => emitter.emit(...args),
        }
    }
}


export {
    filters,
    EventBus,
    LaravelError
}
