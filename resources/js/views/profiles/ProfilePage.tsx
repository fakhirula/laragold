import { Head } from '@inertiajs/react';
import { Heading, VStack, Text, Container, Box, SimpleGrid, HStack, Badge } from '@chakra-ui/react';
import { Card } from '../../components/ui/Card';

export default function ProfilePage() {
  return (
    <>
      <Head title="Profil Saya" />
      <Container maxW="6xl" py={8}>
        <VStack align="stretch" gap={6}>
          <Box>
            <Heading size="xl" color="brand.700" mb={2}>Profil Saya</Heading>
            <Text color="gray.600" fontSize="lg">Kelola informasi akun dan verifikasi KYC Anda</Text>
          </Box>

          <SimpleGrid columns={{ base: 1, md: 2 }} gap={6}>
            {/* Profile Info Card */}
            <Box bg="white" p={6} rounded="xl" shadow="md" borderTop="3px solid" borderColor="brand.500">
              <VStack align="stretch" gap={4}>
                <Heading size="md" color="brand.700">Informasi Akun</Heading>
                <Box>
                  <Text fontSize="sm" color="gray.700">Nama</Text>
                  <Text fontSize="lg" fontWeight="semibold" color="gray.900">Client Sample</Text>
                </Box>
                <Box>
                  <Text fontSize="sm" color="gray.700">Email</Text>
                  <Text fontSize="lg" fontWeight="semibold" color="gray.900">client@laragold.local</Text>
                </Box>
                <Box>
                  <Text fontSize="sm" color="gray.700">Status Akun</Text>
                  <Badge colorScheme="green" fontSize="md" px={3} py={1} rounded="full">Aktif</Badge>
                </Box>
              </VStack>
            </Box>

            {/* KYC Status Card */}
            <Box bg="white" p={6} rounded="xl" shadow="md" borderTop="3px solid" borderColor="orange.500">
              <VStack align="stretch" gap={4}>
                <Heading size="md" color="orange.700">Status Verifikasi</Heading>
                <Box>
                  <Text fontSize="sm" color="gray.700" mb={2}>Status KYC</Text>
                  <Badge colorScheme="orange" fontSize="md" px={3} py={1} rounded="full">Belum Diverifikasi</Badge>
                </Box>
                <Text color="gray.700" fontSize="sm">
                  Verifikasi KYC diperlukan untuk melakukan transaksi. Lengkapi data diri Anda untuk memulai.
                </Text>
              </VStack>
            </Box>
          </SimpleGrid>

          {/* Portfolio Summary */}
          <Box bg="white" p={6} rounded="xl" shadow="md">
            <Heading size="md" color="brand.700" mb={4}>Ringkasan Portofolio</Heading>
            <SimpleGrid columns={{ base: 1, md: 3 }} gap={6}>
              <Box textAlign="center" p={4} bg="brand.50" rounded="lg">
                <Text fontSize="sm" color="gray.700">Total Aset</Text>
                <Heading size="lg" color="brand.700">0.00 g</Heading>
              </Box>
              <Box textAlign="center" p={4} bg="blue.50" rounded="lg">
                <Text fontSize="sm" color="gray.700">Nilai Investasi</Text>
                <Heading size="lg" color="gray.800">Rp 0</Heading>
              </Box>
              <Box textAlign="center" p={4} bg="green.50" rounded="lg">
                <Text fontSize="sm" color="gray.700">Total Transaksi</Text>
                <Heading size="lg" color="gray.800">0</Heading>
              </Box>
            </SimpleGrid>
          </Box>
        </VStack>
      </Container>
    </>
  );
}
