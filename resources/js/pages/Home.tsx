import { Head, Link, usePage, router } from '@inertiajs/react';
import {
  Box,
  Button,
  Heading,
  Text,
  VStack,
  HStack,
  Icon,
} from '@chakra-ui/react';
import { FaCoins } from 'react-icons/fa';
import { useState } from 'react';
import { BalanceCard } from '../components/landing/BalanceCard';
import { GoldHoldings } from '../components/landing/GoldHoldings';
import { PriceChart } from '../components/landing/PriceChart';
import { Menu } from '../components/landing/Menu';

interface HistoricalPrice {
  date: string;
  buy_price: number;
  sell_price: number;
  spread: number;
}

interface PageProps {
  historicalPrices: HistoricalPrice[];
  selectedDays: number;
  [key: string]: any;
}

export default function Home() {
  const { props } = usePage<PageProps>();
  const { historicalPrices, selectedDays } = props;
  const [priceType, setPriceType] = useState<'buy' | 'sell'>('buy');

  const handlePeriodChange = (days: number) => {
    router.get('/', { days }, {
      preserveState: true,
      preserveScroll: true,
    });
  };

  const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
      maximumFractionDigits: 0,
    }).format(value);
  };

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('id-ID', {
      month: 'short',
      day: 'numeric',
    });
  };

  // Reverse array to show oldest to newest (left to right)
  const chartData = [...historicalPrices].reverse().map(price => ({
    date: formatDate(price.date),
    price: priceType === 'buy' ? Number(price.buy_price) : Number(price.sell_price),
    fullDate: price.date,
  }));

  return (
    <>
      <Head title="LaraGold - Platform Jual Beli Emas Digital" />
      
      {/* Mobile Container - True Mobile Viewport */}
      <Box 
        bg="bg" 
        minH="100vh" 
        pb={32}
        display="flex"
        justifyContent="center"
        w="100%"
      >
        <Box maxW="480px" w="100%" bg="bg">
          {/* Hero Section */}
          <Box bg="surface" px={4} py={6} shadow="md" rounded="2xl" m={4}>
            <VStack gap={6} align="stretch">
              <BalanceCard />
              <GoldHoldings />

              {/* Chart and Buy Button */}
              <VStack gap={4} align="stretch">
                <PriceChart
                  chartData={chartData}
                  priceType={priceType}
                  selectedDays={selectedDays}
                  onPriceTypeChange={setPriceType}
                  onPeriodChange={handlePeriodChange}
                  formatCurrency={formatCurrency}
                />

                {/* Buy Gold Button */}
                <Link href="/transaction">
                  <Button 
                    w="full" 
                    size="lg"
                    bg="brand.600"
                    color="white"
                    fontWeight="700"
                    shadow="glow"
                    _hover={{ bg: 'brand.700', shadow: 'xl', transform: 'translateY(-2px)' }}
                    transition="all 0.2s"
                  >
                    <Icon as={FaCoins} mr={2} />
                    Beli Emas Sekarang
                  </Button>
                </Link>

                {/* Text-only Menu */}
                <HStack gap={3} justify="center" flexWrap="wrap" py={2}>
                  <Link href="/gold">
                    <Button variant="outline" colorScheme="brand" size="sm" fontWeight="600" color="brand.500" borderColor="brand.500" _hover={{ bg: 'brand.500', color: 'white' }}>Emas</Button>
                  </Link>
                  <Link href="/pawn">
                    <Button variant="outline" colorScheme="brand" size="sm" fontWeight="600" color="brand.500" borderColor="brand.500" _hover={{ bg: 'brand.500', color: 'white' }}>Gadai</Button>
                  </Link>
                  <Link href="/financing">
                    <Button variant="outline" colorScheme="brand" size="sm" fontWeight="600" color="brand.500" borderColor="brand.500" _hover={{ bg: 'brand.500', color: 'white' }}>Pembiayaan</Button>
                  </Link>
                  <Link href="/portfolio">
                    <Button variant="outline" colorScheme="brand" size="sm" fontWeight="600" color="brand.500" borderColor="brand.500" _hover={{ bg: 'brand.500', color: 'white' }}>Portofolio</Button>
                  </Link>
                </HStack>
              </VStack>
            </VStack>
          </Box>

          {/* Floating Bottom Bar: Home + Menu */}
          <Menu />
        </Box>
      </Box>
    </>
  );
}
