export const ORDER_STATUS = {
  REQUESTED: 'requested',
  APPROVED: 'approved',
  CANCELLED: 'cancelled',
} as const;

export type OrderStatus = (typeof ORDER_STATUS)[keyof typeof ORDER_STATUS];

export interface Order {
  orderId: number;
  requesterName: string;
  destination: string;
  departureDate: string;
  arrivalDate: string;
  status: OrderStatus;
}

export interface OrderCardProps {
  order: Order;
  isAdmin: boolean;
  onEdit: (order: Order) => void;
}

export interface OrderModalProps {
  order: Order | null;
  show: boolean;
  saving: boolean;
  error: string | null;
  onClose: () => void;
  onSave: (status: OrderStatus) => Promise<void>;
}
