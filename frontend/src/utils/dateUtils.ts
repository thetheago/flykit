import { date } from 'quasar';

export const DATE_FORMAT = {
  DISPLAY: 'DD/MM/YYYY', // Para exibição na UI
  API: 'DD-MM-YYYY', // Para comunicação com a API
  ISO: 'YYYY-MM-DD', // Para manipulação interna
} as const;

// Converte de qualquer formato para DD/MM/YYYY (exibição)
export function formatDateForDisplay(dateStr: string): string {
  if (!dateStr) return '';
  return date.formatDate(dateStr, DATE_FORMAT.DISPLAY);
}

// Converte de qualquer formato para DD-MM-YYYY (API)
export function formatDateForApi(dateStr: string): string {
  if (!dateStr) return '';
  return date.formatDate(dateStr, DATE_FORMAT.API);
}

// Converte de DD/MM/YYYY ou DD-MM-YYYY para YYYY-MM-DD (manipulação)
export function parseDateToISO(dateStr: string): string {
  if (!dateStr) return '';
  return date.formatDate(dateStr, DATE_FORMAT.ISO);
}

// Converte de DD-MM-YYYY (API) para DD/MM/YYYY (exibição)
export function formatApiDateToDisplay(apiDate: string): string {
  if (!apiDate) return '';
  const isoDate = parseDateToISO(apiDate);
  return formatDateForDisplay(isoDate);
}

export function getMinDate(yearsAgo: number = 1): string {
  const minDate = new Date();
  minDate.setFullYear(minDate.getFullYear() - yearsAgo);
  return date.formatDate(minDate, DATE_FORMAT.ISO);
}

export function getMaxDate(yearsAhead: number = 5): string {
  const maxDate = new Date();
  maxDate.setFullYear(maxDate.getFullYear() + yearsAhead);
  return date.formatDate(maxDate, DATE_FORMAT.ISO);
}

export function isValidDateRange(startDate: string, endDate: string): boolean {
  try {
    const [startDay, startMonth, startYear] = startDate.split(/[-/]/).map(Number);
    const [endDay, endMonth, endYear] = endDate.split(/[-/]/).map(Number);

    if (!startDay || !startMonth || !startYear || !endDay || !endMonth || !endYear) {
      return false;
    }

    const start = new Date(startYear, startMonth - 1, startDay);
    const end = new Date(endYear, endMonth - 1, endDay);

    return start <= end;
  } catch {
    return false;
  }
}
