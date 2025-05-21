export type OrderStatus = 'requested' | 'approved' | 'rejected' | 'completed';

export interface Order {
  orderId: string;
  requesterName: string;
  destination: string;
  departureDate: string;
  arrivalDate: string;
  status: OrderStatus;
}

export interface CreateOrderFormData {
  orderId: string;
  requesterName: string;
  destination: string;
  departureDate: string;
  arrivalDate: string;
}

export interface ValidationErrors {
  orderId?: string;
  requesterName?: string;
  destination?: string;
  departureDate?: string;
  arrivalDate?: string;
}
