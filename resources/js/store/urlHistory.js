import { defineStore } from 'pinia'
import { LocalStorage } from '@/storage'

export const useUrlHistory = defineStore('urlHistory', {
  state: () => {
    return {
      history: LocalStorage.getOr(['urlHistory'], []),
      preventNext: false
    }
  },
  actions: {
    push(url) {
      if (url == this.last) return
      if (this.preventNext) {
        this.preventNext = false
        return
      }
      this.history.push(url)
      LocalStorage.set(['urlHistory'], this.history)
    },
    pop(preventNext = false) {
      if (!this.last) return null
      if (preventNext) this.preventNextPush()
      return this.history.pop()
    },
    preventNextPush() {
      this.preventNext = true
    }
  },
  getters: {
    last: state => {
      return state.history.length
        ? state.history[state.history.length - 1]
        : null
    }
  }
})
