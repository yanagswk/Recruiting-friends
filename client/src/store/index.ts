import { InjectionKey } from "vue";
import { createStore, Store, useStore as baseUseStore } from "vuex";
import * as MutationTypes from "./mutationType";

interface FlashMsg {
  is_display: boolean;
  message: string;
  bg_color: string;
  text_color: string;
  image_path: string;
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
      image_path: "",
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
      state.flash_msg.image_path =
        "M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z";
      state.flash_msg.is_display = true;
      setTimeout(() => {
        store.commit(MutationTypes.DEL_FLASH_MSG);
      }, 5000);
    },
    [MutationTypes.ERR_FLASH_MSG](state, message: string) {
      state.flash_msg.message = message;
      state.flash_msg.bg_color = "bg-rose-600";
      state.flash_msg.text_color = "text-rose-600";
      state.flash_msg.image_path =
        "M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z";
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
