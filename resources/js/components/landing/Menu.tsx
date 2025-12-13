import { Box, Button, HStack, Icon } from '@chakra-ui/react';
import { Link } from '@inertiajs/react';
import { FaHome, FaBars } from 'react-icons/fa';

export function Menu() {
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
        maxW="480px"
        bg="elevated"
        border="1px solid"
        borderColor="border"
        rounded="3xl"
        shadow="xl"
        p={3}
        backdropFilter="blur(10px)"
      >
        <HStack gap={4} justify="center">
          <Link href="/">
            <Button 
              w="100%" 
              h="60px" 
              variant="ghost"
              bg="transparent"
              color="brand.500"
              _hover={{ color: 'white' }}
              transition="all 0.2s"
            >
              <Icon as={FaHome} w={6} h={6} />
            </Button>
          </Link>
          <Link href="/articles">
            <Button 
              w="100%" 
              h="60px" 
              variant="ghost"
              bg="transparent"
              color="brand.500"
              _hover={{ color: 'white' }}
              transition="all 0.2s"
            >
              <Icon as={FaBars} w={6} h={6} />
            </Button>
          </Link>
        </HStack>
      </Box>
    </Box>
  );
}
