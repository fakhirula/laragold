import { Box, Button, HStack, Text, VStack } from '@chakra-ui/react';
import { AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts';

interface PriceChartProps {
  chartData: Array<{
    date: string;
    price: number;
  }>;
  priceType: 'buy' | 'sell';
  selectedDays: number;
  onPriceTypeChange: (type: 'buy' | 'sell') => void;
  onPeriodChange: (days: number) => void;
  formatCurrency: (value: number) => string;
}

const PERIOD_OPTIONS = [
  { label: '1 Minggu', days: 7 },
  { label: '1 Bulan', days: 30 },
  { label: '3 Bulan', days: 90 },
  { label: '1 Tahun', days: 365 },
];

export function PriceChart({
  chartData,
  priceType,
  selectedDays,
  onPriceTypeChange,
  onPeriodChange,
  formatCurrency,
}: PriceChartProps) {
  return (
    <Box bg="elevated" rounded="xl" p={4} border="1px solid" borderColor="border" shadow="md">
      <VStack gap={3} align="stretch">
        <HStack justify="space-between">
          <VStack align="start" gap={1}>
            <Text fontSize="xs" color="subtext" fontWeight="600">
              {priceType === 'buy' ? 'Harga Beli' : 'Harga Jual'}
            </Text>
            <Text fontSize="xl" fontWeight="800" color="brand.500">
              {formatCurrency(chartData[chartData.length - 1]?.price || 0)}
            </Text>
          </VStack>
          <HStack gap={2}>
            <Button
              size="sm"
              onClick={() => onPriceTypeChange('buy')}
              bg={priceType === 'buy' ? 'brand.600' : 'transparent'}
              color={priceType === 'buy' ? 'white' : 'brand.500'}
              borderWidth={1}
              borderColor="brand.500"
              fontWeight="700"
              _hover={{ bg: priceType === 'buy' ? 'brand.700' : 'brand.600', color: 'white' }}
            >
              Beli
            </Button>
            <Button
              size="sm"
              onClick={() => onPriceTypeChange('sell')}
              bg={priceType === 'sell' ? 'brand.600' : 'transparent'}
              color={priceType === 'sell' ? 'white' : 'brand.500'}
              borderWidth={1}
              borderColor="brand.500"
              fontWeight="700"
              _hover={{ bg: priceType === 'sell' ? 'brand.700' : 'brand.600', color: 'white' }}
            >
              Jual
            </Button>
          </HStack>
        </HStack>

        {/* Mini Chart */}
        <Box h="150px" w="full">
          <ResponsiveContainer width="100%" height="100%">
            <AreaChart data={chartData} margin={{ top: 5, right: 10, left: -30, bottom: 5 }}>
              <defs>
                <linearGradient id="colorPrice" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="5%" stopColor="#00e666" stopOpacity={0.2}/>
                  <stop offset="95%" stopColor="#00e666" stopOpacity={0}/>
                </linearGradient>
              </defs>
              <CartesianGrid strokeDasharray="3 3" stroke="#e2e8f0" vertical={false} />
              <XAxis 
                dataKey="date" 
                tick={{ fontSize: 10 }}
                tickLine={false}
                axisLine={false}
                interval="preserveStartEnd"
              />
              <YAxis 
                tick={{ fontSize: 10 }}
                tickLine={false}
                axisLine={false}
                tickFormatter={(value) => `${(value / 1000000).toFixed(1)}jt`}
                width={35}
                domain={['auto', 'auto']}
                tickCount={3}
              />
              <Tooltip 
                formatter={(value: number) => formatCurrency(value)}
                contentStyle={{
                  backgroundColor: '#fff',
                  border: '1px solid #e2e8f0',
                  borderRadius: '6px',
                  fontSize: '10px'
                }}
              />
              <Area 
                type="monotone" 
                dataKey="price" 
                stroke="#00e666"
                strokeWidth={2}
                fill="url(#colorPrice)"
                dot={false}
              />
            </AreaChart>
          </ResponsiveContainer>
        </Box>

        {/* Period Filter */}
        <HStack gap={2} justify="center" flexWrap="wrap">
          {PERIOD_OPTIONS.map((option) => (
            <Button
              key={option.days}
              size="sm"
              onClick={() => onPeriodChange(option.days)}
              bg={selectedDays === option.days ? 'brand.600' : 'transparent'}
              color={selectedDays === option.days ? 'white' : 'text'}
              borderWidth={1}
              borderColor={selectedDays === option.days ? 'brand.600' : 'border'}
              fontWeight="600"
              _hover={{ bg: selectedDays === option.days ? 'brand.700' : 'elevated' }}
            >
              {option.label}
            </Button>
          ))}
        </HStack>
      </VStack>
    </Box>
  );
}
