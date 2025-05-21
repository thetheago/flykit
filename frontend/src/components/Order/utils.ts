import { type OrderStatus, ORDER_STATUS } from './types';

export function formatDate(dateString: string): string {
  if (!dateString) return '';

  // Converte dd-mm-yyyy para yyyy-mm-dd para o Date
  const [day, month, year] = dateString.split('-');
  if (!day || !month || !year) return '';

  const date = new Date(`${year}-${month}-${day}`);
  if (isNaN(date.getTime())) return '';

  return date.toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  });
}

export function getStatusLabel(status: OrderStatus): string {
  const labels: Record<OrderStatus, string> = {
    [ORDER_STATUS.REQUESTED]: 'Solicitado',
    [ORDER_STATUS.APPROVED]: 'Aprovado',
    [ORDER_STATUS.CANCELLED]: 'Cancelado',
  };
  return labels[status];
}
