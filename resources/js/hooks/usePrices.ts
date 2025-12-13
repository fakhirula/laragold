import { useEffect, useState } from 'react';

export type PriceRow = {
  product: string;
  type: 'buy' | 'sell';
  price_per_gram: number;
  recorded_at: string;
};

export function usePrices() {
  const [rows, setRows] = useState<PriceRow[]>([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    setLoading(true);
    // TODO: fetch from API endpoint (Laravel route) e.g. /api/prices
    const timer = setTimeout(() => {
      setRows([
        { product: 'Antam LM 1g', type: 'buy', price_per_gram: 1100000, recorded_at: new Date().toISOString() },
        { product: 'Antam LM 1g', type: 'sell', price_per_gram: 1150000, recorded_at: new Date().toISOString() },
        { product: 'UBS LM 1g', type: 'buy', price_per_gram: 1095000, recorded_at: new Date().toISOString() },
        { product: 'UBS LM 1g', type: 'sell', price_per_gram: 1148000, recorded_at: new Date().toISOString() },
      ]);
      setLoading(false);
    }, 400);
    return () => clearTimeout(timer);
  }, []);

  return { rows, loading };
}
