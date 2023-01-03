import {parseISO, format} from 'date-fns'
import mitt from 'mitt'

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
    EventBus
}
