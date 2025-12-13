import { Head } from '@inertiajs/react';
import { Heading, Table, Thead, Tbody, Tr, Th, Td, Container } from '@chakra-ui/react';

export default function ProfileIndex() {
  return (
    <>
      <Head title="Profil" />
      <Container maxW="6xl" py={6}>
        <Heading size="md" mb={4} color="brand.700">Profil Pengguna</Heading>
      <Table variant="simple" bg="white" rounded="md" overflow="hidden">
        <Thead>
          <Tr>
            <Th>Field</Th>
            <Th>Nilai</Th>
          </Tr>
        </Thead>
        <Tbody>
          <Tr>
            <Td>Nama</Td>
            <Td>Client Sample</Td>
          </Tr>
          <Tr>
            <Td>Status KYC</Td>
            <Td>Belum Diverifikasi</Td>
          </Tr>
        </Tbody>
      </Table>
      </Container>
    </>
  );
}
