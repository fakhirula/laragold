import { Box, Button, HStack, Icon, VStack } from '@chakra-ui/react';
import { Link } from '@inertiajs/react';
import { FaCoins, FaDollarSign, FaChartLine, FaWallet } from 'react-icons/fa6';

const MENU_ITEMS = [
  {
    label: 'Emas',
    icon: FaCoins,
    route: '/gold',
    color: 'brand.600',
  },
  {
    label: 'Gadai',
    icon: FaDollarSign,
    route: '/pawn',
    color: 'blue.600',
  },
  {
    label: 'Pembiayaan',
    icon: FaChartLine,
    route: '/financing',
    color: 'purple.600',
  },
  {
    label: 'Portofolio',
    icon: FaWallet,
    route: '/portfolio',
    color: 'orange.600',
  },
];

export function ServiceMenu() {
  return (
    <Box
      position="fixed"
      bottom={0}
      left={0}
      right={0}
      zIndex={10}
      display="flex"
      justifyContent="center"
      px={4}
      pb={4}
    >
      <Box
        w="100%"
        maxW="480px"
        bg="white"
        border="1px solid"
        borderColor="gray.200"
        rounded="xl"
        shadow="lg"
        p={2}
      >
        <HStack gap={2} justify="space-between">
          {MENU_ITEMS.map((item) => (
            <Link key={item.route} href={item.route} style={{ flex: 1 }}>
              <Button
                as="div"
                w="100%"
                h="56px"
                bg="white"
                rounded="md"
                variant="ghost"
                _hover={{ bg: 'gray.50' }}
              >
                <VStack gap={1} align="center" justify="center">
                  <Icon as={item.icon} w={5} h={5} color={item.color} />
                </VStack>
              </Button>
            </Link>
          ))}
        </HStack>
      </Box>
    </Box>
  );
}
