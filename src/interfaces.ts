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
  showFullScreen: Function;
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

export const defaultItemShop:ItemShop = {
  idItem: 0,
  imagen: "",
  descripcion: "",
  imagenAlt: "",
  nombre: "",
  precio: 0,
  cantidad: 0
}

export interface loginGeneral {
  username: string,
  password: string
}

export interface registerUser {
  username: string,
  password: string,
  id_user: number,
  email: string,
  first_name: string,
  last_name: string,
  born_year: number,
  born_month: number,
  born_day: number,
  age: number,
}

interface Address {
  street:string,
  street_alt?: string,
  colony: string,
  country: string,
  code_postal: number,
  external_number: number,
  internal_number: number,
}

export interface registerRestaurant {
  restaurantname: string,
  password: string,
  id_restaurant: number,
  email: string,
  rfc: string,
  address: Address,
  
}

