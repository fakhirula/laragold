import { Head, Link } from '@inertiajs/react';
import { Box, Button, Heading, VStack, Container, Input, Text } from '@chakra-ui/react';

export default function Register() {
  return (
    <>
      <Head title="Register" />
      <Box 
        minH="calc(100vh - 60px)" 
        bgGradient="linear(to-br, brand.50, white, brand.100)"
        display="flex"
        alignItems="center"
        py={12}
      >
        <Container maxW="md">
          <Box 
            bg="white" 
            p={8} 
            rounded="2xl" 
            shadow="2xl"
            borderTop="4px solid"
            borderColor="brand.500"
          >
            <VStack gap={6} align="stretch">
              <VStack gap={2} textAlign="center">
                <Heading size="lg" color="brand.700">Daftar Akun Baru</Heading>
                <Text color="gray.600">Mulai investasi emas digital Anda</Text>
              </VStack>
              
              <VStack as="form" align="stretch" gap={4}>
                <Box>
                  <Text mb={2} fontWeight="medium" color="gray.700">Nama Lengkap</Text>
                  <Input 
                    type="text" 
                    placeholder="Nama lengkap"
                    size="lg"
                    focusBorderColor="brand.500"
                  />
                </Box>
                <Box>
                  <Text mb={2} fontWeight="medium" color="gray.700">Email</Text>
                  <Input 
                    type="email" 
                    placeholder="you@example.com"
                    size="lg"
                    focusBorderColor="brand.500"
                  />
                </Box>
                <Box>
                  <Text mb={2} fontWeight="medium" color="gray.700">Password</Text>
                  <Input 
                    type="password" 
                    placeholder="••••••••"
                    size="lg"
                    focusBorderColor="brand.500"
                  />
                </Box>
                <Button 
                  type="submit" 
                  colorScheme="brand" 
                  size="lg"
                  w="full"
                  mt={2}
                >
                  Daftar Sekarang
                </Button>
              </VStack>

              <Box textAlign="center" pt={4} borderTop="1px solid" borderColor="gray.200">
                <Text color="gray.600">
                  Sudah punya akun?{' '}
                  <Link href="/login">
                    <Text as="span" color="brand.600" fontWeight="semibold" _hover={{ color: 'brand.700' }}>
                      Masuk di sini
                    </Text>
                  </Link>
                </Text>
              </Box>
            </VStack>
          </Box>
        </Container>
      </Box>
    </>
  );
}
