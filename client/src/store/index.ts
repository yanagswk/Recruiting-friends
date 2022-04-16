import { InjectionKey } from "vue";
import { createStore, Store, useStore as baseUseStore } from "vuex";
import * as MutationTypes from "./mutationType";

interface FlashMsg {
  is_display: boolean;
  message: string;
  color: string;
}

// stateの型定義
interface State {
  is_loading: boolean;
  flash_msg: FlashMsg;
}

// storeをprovide/injectするためのキー
export const key: InjectionKey<Store<State>> = Symbol();

// store本体
export const store = createStore<State>({
  state: {
    is_loading: false,
    flash_msg: {
      is_display: false,
      message: "",
      color: "",
    },
  },
  mutations: {
    [MutationTypes.IS_LOADING](state, is_loading: boolean) {
      state.is_loading = is_loading;
    },
    [MutationTypes.SHOW_FLASH_MSG](state, flash_msg: FlashMsg) {
      state.flash_msg.message = flash_msg.message;
      state.flash_msg.color = flash_msg.color;
      state.flash_msg.is_display = true;
    },
    [MutationTypes.DEL_FLASH_MSG](state) {
      state.flash_msg.message = "";
      state.flash_msg.color = "";
      state.flash_msg.is_display = false;
    },
  },
});

// useStoreを使う時にキーの指定を省略するためのラッパー関数
export const useStore = () => {
  return baseUseStore(key);
};
