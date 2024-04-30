
export interface ItemShop {
  idItem: number;
  imagen: string;
  descripcion: string;
  imagenAlt: string;
  nombre: string;
  precio: number;
  cantidad: number;
}

export interface ItemShopComponent {
  itemShop: ItemShop;
  addItem: Function;
  deleteItem: Function;
}

export interface restaurantData {
  nombreRestaurante: string;
  nombreCliente: string;
  idRestaurante: number;
  itemShopArray: ItemShop[];
}

export const defaultItemShopArray = (): ItemShop[] => [{
  idItem: 0,
  imagen: "",
  descripcion: "",
  imagenAlt: "",
  nombre: "",
  precio: 0,
  cantidad: 0
}];

