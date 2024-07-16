import {Dish} from './dish.js';

export interface Order {
  id: number;
  dish: Omit<Dish,'ingredients'>;
  created_at: Date;
  updated_at: Date;
  status: OrderStatus;
}

export enum OrderStatus {
  Pending = 'pending',
  Cooking = 'cooking',
  Completed = 'completed',
}
