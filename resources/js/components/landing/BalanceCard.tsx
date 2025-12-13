import { Box, Heading, Text } from '@chakra-ui/react';

export function BalanceCard() {
  return (
    <Box 
      bgGradient="linear(to-br, brand.600, brand.800)" 
      rounded="xl" 
      p={6} 
      color="white" 
      shadow="glow"
      position="relative"
      overflow="hidden"
      _before={{
        content: '""',
        position: 'absolute',
        top: 0,
        left: 0,
        right: 0,
        bottom: 0,
        bgGradient: 'linear(to-br, brand.400, transparent)',
        opacity: 0.2,
      }}
    >
      <Box position="relative" zIndex={1}>
        <Text fontSize="xs" opacity={0.9} mb={2} fontWeight="600">Saldo Rekening Utama</Text>
        <Heading size="2xl" mb={0} fontWeight="800" letterSpacing="tight">Rp 5.000.000</Heading>
      </Box>
    </Box>
  );
}
