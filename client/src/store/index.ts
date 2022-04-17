import { InjectionKey } from "vue";
import { createStore, Store, useStore as baseUseStore } from "vuex";
import * as MutationTypes from "./mutationType";

interface FlashMsg {
  is_display: boolean;
  message: string;
  bg_color: string;
  text_color: string;
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
      bg_color: "",
      text_color: "",
    },
  },
  mutations: {
    [MutationTypes.IS_LOADING](state, is_loading: boolean) {
      state.is_loading = is_loading;
    },
    [MutationTypes.INFO_FLASH_MSG](state, message: string) {
      state.flash_msg.message = message;
      state.flash_msg.bg_color = "bg-emerald-500";
      state.flash_msg.text_color = "text-emerald-500";
      state.flash_msg.is_display = true;
      setTimeout(() => {
        store.commit(MutationTypes.DEL_FLASH_MSG);
      }, 5000);
    },
    [MutationTypes.ERR_FLASH_MSG](state, message: string) {
      state.flash_msg.message = message;
      state.flash_msg.bg_color = "bg-rose-600";
      state.flash_msg.text_color = "text-rose-600";
      state.flash_msg.is_display = true;
      setTimeout(() => {
        store.commit(MutationTypes.DEL_FLASH_MSG);
      }, 5000);
    },
    [MutationTypes.DEL_FLASH_MSG](state) {
      state.flash_msg.is_display = false;
      // state.flash_msg.message = "";
      // state.flash_msg.color = "";
    },
  },
});

// useStoreを使う時にキーの指定を省略するためのラッパー関数
export const useStore = () => {
  return baseUseStore(key);
};
