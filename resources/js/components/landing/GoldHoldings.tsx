import { Box, Heading, Text, HStack } from '@chakra-ui/react';

export function GoldHoldings() {
  return (
    <HStack gap={4} justify="space-between">
      {/* Gold Grams */}
      <Box flex={1} bg="elevated" rounded="xl" p={4} border="1px solid" borderColor="border" shadow="md">
        <Text fontSize="xs" color="subtext" mb={2} fontWeight="600">Emas yang Dimiliki</Text>
        <Heading size="xl" color="brand.500" mb={1} fontWeight="800">50.5 gr</Heading>
        <Text fontSize="xs" color="muted">berat total</Text>
      </Box>

      {/* Gold Value */}
      <Box flex={1} bg="elevated" rounded="xl" p={4} border="1px solid" borderColor="border" shadow="md">
        <Text fontSize="xs" color="subtext" mb={2} fontWeight="600">Nilai Emas Sekarang</Text>
        <Heading size="xl" color="brand.500" mb={1} fontWeight="800">Rp 2.5jt</Heading>
        <Text fontSize="xs" color="muted">harga saat ini</Text>
      </Box>
    </HStack>
  );
}
